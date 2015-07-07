//
//  SetupCompleteViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/8/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "SetupCompleteViewController.h"
#import "TheNavigationController.h"

@interface SetupCompleteViewController (){
    NSMutableData *responseData;
}

@end

@implementation SetupCompleteViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.title = @"Setup Complete";
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)checkSelectionAction:(id)sender {
    NSString *sendString = @"http://hwsanta.com/app/setupcomplete.php";
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:sendString]];
    
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
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    NSString *response = [[NSString alloc] initWithData:responseData encoding: NSASCIIStringEncoding];
    if([response isEqualToString:@"early"]){
        [[[UIAlertView alloc] initWithTitle:@"Not yet" message:@"Selection Process has not started yet.  Please check back soon" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    }else{
        [(TheNavigationController *)self.navigationController nextAfterSetupComplete];
    }
    
}
@end
