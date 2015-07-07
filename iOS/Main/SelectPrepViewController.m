//
//  SelectPrepViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/3/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "SelectPrepViewController.h"
#import <QuartzCore/QuartzCore.h>
#import "TheNavigationController.h"
#import "GameState.h"

@interface SelectPrepViewController (){
    BOOL isRequesting;
    NSMutableData *responseData;
}

@end

@implementation SelectPrepViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self prepShadows:self.header];
    self.loadingChoices.hidden = YES;
    self.loadingIndicator.hidden = YES;
}
- (void)prepShadows:(UIView *)view{
    view.layer.masksToBounds = NO;
    view.layer.shadowOffset = CGSizeMake(0, 10);
    view.layer.shadowRadius = 5;
    view.layer.shadowOpacity = 0.2;
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)startSelected:(id)sender {
    if(isRequesting)return;
    isRequesting = YES;
    self.loadingChoices.hidden = NO;
    self.loadingIndicator.hidden = NO;
    [self.loadingIndicator startAnimating];
    NSString *userid = [[GameState sharedGameState] getUserID];
    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/selectprep.php?userid=%@",userid];
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
}











- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    isRequesting = NO;
    self.loadingIndicator.hidden = YES;
    [self.loadingIndicator stopAnimating];
    self.loadingChoices.hidden = YES;
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server. Try again" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    isRequesting = NO;
    self.loadingIndicator.hidden = YES;
    [self.loadingIndicator stopAnimating];
    self.loadingChoices.hidden = YES;
    
    NSString *resp = [[NSString alloc] initWithData:responseData encoding:NSASCIIStringEncoding];
    if([resp isEqualToString:@"wait"]){
        [[[UIAlertView alloc] initWithTitle:@"Wait" message:@"Too many other people are currently selecting. Try again in a few seconds." delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
        return;
    }
    
    NSError *error;
    NSArray *response = [NSJSONSerialization JSONObjectWithData:responseData options:kNilOptions error:&error];
    [[GameState sharedGameState] setSelectionChoices:response];
    
    [(TheNavigationController *)[self navigationController] nextAfterSelectPrep];
    
}

@end
