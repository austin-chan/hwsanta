//
//  SelectNowViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/3/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "SelectNowViewController.h"
#import <QuartzCore/QuartzCore.h>
#import "TheNavigationController.h"
#import "GameState.h"

@interface SelectNowViewController (){
    NSInteger timer;
    BOOL paused;
    
    NSString *name;
    NSString *grade;
    NSString *userid;
}

@end

@implementation SelectNowViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];

    [self setupChoices];
    timer = 30;
    paused = NO;
    [self startTimer];
    
    [self prepShadows:self.header];
    [self prepShadows:self.countdownView];
    [self prepShadows:self.firstChoiceView];
    [self prepShadows:self.secondChoiceView];
    [self prepShadows:self.thirdChoiceView];
    [self prepShadows:self.fourthChoiceView];
    [self prepShadows:self.fifthChoiceView];
    
    
}
- (void)prepShadows:(UIView *)view{
    view.layer.masksToBounds = NO;
//    view.layer.cornerRadius = 8;  if you like rounded corners
    view.layer.shadowOffset = CGSizeMake(0, 5);
    view.layer.shadowRadius = 3;
    view.layer.shadowOpacity = 0.2;
}

- (void)startTimer{
        [NSTimer scheduledTimerWithTimeInterval:1.0
                                     target:self
                                   selector:@selector(newSecond:)
                                   userInfo:nil
                                    repeats:YES];
}

-(void)newSecond:(NSTimer *)nstimer{
    if(!paused){
        timer--;
        if(timer == -1){
            paused = YES;
            [self confirm];
        }else{
            self.countdownLabel.text = [NSString stringWithFormat:@"%i", timer];            
        }
    }
}

- (IBAction)selectRecipient:(id)sender {
    
    paused = YES;
    
    UIButton *send = sender;
    UIView *recipientView = [send superview];
    NSArray *subviews = [recipientView subviews];
    
    NSInteger count = 0;
    
    for(int x = 0; x < [subviews count]; x++){
        if([[subviews objectAtIndex:x] isKindOfClass:[UILabel class]]){
            count++;
            if(count == 1){
                name = [(UILabel *)[subviews objectAtIndex:x] text];
                //Name
            }else if(count == 2){
                grade = [(UILabel *)[subviews objectAtIndex:x] text];
                //Grade
            }else if(count == 3){
                userid = [(UILabel *)[subviews objectAtIndex:x] text];
                //User ID
            }
        }
    }
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Confirm" message:[@"Are you sure you want to pick:\n" stringByAppendingString:name] delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles: @"Confirm", nil];
    
    [alert show];
}

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    if(buttonIndex == 0){
        //Cancel
        
        paused = NO;
    }else{
        //Confirm
        
        [self confirm];
    }
}

- (void)setupChoices{
    NSArray *choices = [[GameState sharedGameState] getSelectionChoices];
    NSArray *views = [NSArray arrayWithObjects:self.firstChoiceView, self.secondChoiceView, self.thirdChoiceView, self.fourthChoiceView, self.fifthChoiceView, nil];
    
    for(int x = 0; x < [views count]; x++){
        
        if(x > [choices count] - 1){
            ((UIView *)[views objectAtIndex:x]).hidden = YES;
            continue;
        }
        NSDictionary *person = [choices objectAtIndex:x];
        
        NSArray *subviews = [[views objectAtIndex:x] subviews];
        for(int y = 0; y < [subviews count]; y++){
            id label = [subviews objectAtIndex:y];
            if(y == 0){
                
            }
            if(y == 1){
                ((UILabel *)label).text = [person objectForKey:@"name"];
            }
            if(y == 2){
                ((UILabel *)label).text = [person objectForKey:@"grade"];
            }
            if(y == 3){
                ((UILabel *)label).text = [NSString stringWithFormat:@"%@",[person objectForKey:@"userid"]];
            }
        }
    }
}

- (void)confirm{
    [((TheNavigationController *)[self navigationController]) selectUserID:userid];
}

@end
